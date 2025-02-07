import Link from 'next/link'

export default function NavbarButton({
    href,
    name,
}: {
    href: string
    name: string
}) {
    return (
        <Link href={href} className="bg-white">
            {name}
        </Link>
    )
}
