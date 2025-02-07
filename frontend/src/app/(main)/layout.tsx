'use client'

export default function MainLayout({
    children,
}: {
    children: React.ReactNode
}) {
    return (
        <>
            <div className="w-full rounded-lg overflow-scroll relative bg-bg_secondary p-2">
                <div className="absolute h-[2000px]">{children}</div>
            </div>
        </>
    )
}
